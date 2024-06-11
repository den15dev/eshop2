import { csrf, lang } from "../../common/global.js";
import { showErrorMessage } from "../../common/modals.js";


export function post(
    service, // e.g. 'product' or 'category'
    action, // e.g. 'saveAttribute'
    args,
    errorFunc = () => {},
    successFunc = () => {},
) {
    fetch(`/${lang}/admin/ajax`, {
        method: 'post',
        headers: {
            "Content-Type": "application/json",
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrf,
        },
        body: JSON.stringify({
            service: service,
            action: action,
            args: args,
        }),
    })
    .then(response => {
        if (!response.ok && response.status !== 422) {
            const error = new Error();
            error.status = response.status;
            error.statusText = response.statusText;
            throw error;
        }
        return response.json();
    })
    .then(result => {
        result.errors ? errorFunc(result) : successFunc(result);
    })
    .catch(err => showErrorMessage(err));
}


export function get(
    service, // e.g. 'product' or 'category'
    action, // e.g. 'saveAttribute'
    params,
    accept, // 'json' or 'html'
    errorFunc = () => {},
    successFunc = () => {},
) {
    const searchParams = objectToQueryString({
        service: service,
        action: action,
        args: params,
    });

    const options = { method: 'get' };
    if (accept === 'json') options.headers = { 'Accept': 'application/json' };

    fetch(`/${lang}/admin/ajax/${accept}?${searchParams}`, options)
    .then(response => {
        if (!response.ok && response.status !== 422) {
            const error = new Error();
            error.status = response.status;
            error.statusText = response.statusText;
            throw error;
        }
        return accept === 'json'
            ? response.json()
            : response.text();
    })
    .then(result => {
        result.errors ? errorFunc(result) : successFunc(result);
    })
    .catch(err => showErrorMessage(err));
}


function objectToQueryString(object) {
    const simplifiedData = objectToQueryStringHelper(object, []);
    const queryStrings = simplifiedData.map(
        ({ keyPath: [firstKey, ...otherKeys], value }) => {
            const nestedPath = otherKeys.map((key) => `[${key}]`).join("");
            return `${firstKey}${nestedPath}=${
                (value != null) ? encodeURIComponent(`${value}`) : ""
            }`;
        }
    );
    return queryStrings.join("&");
}

function objectToQueryStringHelper(object, path, result) {
    return Object.entries(object).reduce((acc, [key, value]) => {
        if ((value != null) || (value?.length != 0)) {
            typeof value === 'object'
                ? acc.push(
                    ...objectToQueryStringHelper(
                        value,
                        [...path, key],
                        result
                    )
                )
                : acc.push({ keyPath: [...path, key], value });
        }
        return acc;
    }, []);
}


/**
 * Convert to objects form fields with names
 * containing square brackets like "spec[ru]".
 */
export function convertToNestedObjects(obj) {
    const outObj = {};

    for (let key in obj) {
        const keyParse = key.match(/(.+)\[(.+)\]$/);
        if (keyParse) {
            const newObj = keyParse[1];
            const newKey = keyParse[2];

            if (newObj in outObj) {
                outObj[newObj][newKey] = obj[key];
            } else {
                outObj[newObj] = {};
                outObj[newObj][newKey] = obj[key];
            }
        } else {
            outObj[key] = obj[key];
        }
    }

    return outObj;
}


/**
 * Remove nested objects whose all fields are empty.
 * For example:
 * units: {
 *     ru: '',
 *     en: '',
 *     de: '',
 * }
 * will be removed.
 */
export function removeEmptyObjects(obj) {
    for (let key in obj) {
        if (typeof obj[key] === 'object' && !Array.isArray(obj[key]) && obj[key] !== null) {
            const innerObj = obj[key];

            let isEmpty = true;
            for (let innerKey in innerObj) {
                if (innerObj[innerKey]) isEmpty = false;
            }

            if (isEmpty) delete obj[key];
        }
    }

    return obj;
}


export function showFieldErrors(form, errors) {
    for (const fieldName in errors) {
        const fieldParts = fieldName.split('.');

        if (fieldParts.length > 1) {
            const lastName = fieldParts.pop();
            const preLastName = fieldParts.pop();
            const elem = form.querySelector(`*[name="${lastName}"]`) || form.querySelector(`*[name="${preLastName}[${lastName}]"]`);

            if (elem) showFieldError(elem, errors[fieldName][0]);
        }
    }
}


export function showFieldError(field, message) {
    field.classList.add('is-invalid');
    field.parentNode.querySelector('.invalid-feedback').innerText = message;
}

export function hideFieldError(field) {
    field.classList.remove('is-invalid');
    field.parentNode.querySelector('.invalid-feedback').innerText = '';
}