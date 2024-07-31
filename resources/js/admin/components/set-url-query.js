const url = new URL(window.location.href);
export const searchParams = url.searchParams;


export function setURL() {
    const url = new URL(window.location.href);

    url.search = '';
    searchParams.forEach((value, key) => {
        url.searchParams.set(key, value);
    });

    window.history.pushState(null, '', url.toString());
}