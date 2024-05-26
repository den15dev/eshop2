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


export function showFieldError(field, message) {
    field.classList.add('is-invalid');
    field.parentNode.querySelector('.invalid-feedback').innerText = message;
}

export function hideFieldError(field) {
    field.classList.remove('is-invalid');
    field.parentNode.querySelector('.invalid-feedback').innerText = '';
}