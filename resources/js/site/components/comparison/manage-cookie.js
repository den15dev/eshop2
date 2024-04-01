import { getCookieValue } from "../../../common/global.js";

const cookieName = 'comparison';


export function getComparisonArray() {
    const comparisonCookie = getCookieValue(cookieName);
    return comparisonCookie ? JSON.parse(decodeURIComponent(comparisonCookie)) : null;
}

export function setCookie(comparisonArr) {
    document.cookie = cookieName + '=' + encodeURIComponent(JSON.stringify(comparisonArr)) + '; path=/; max-age=2592000';
}

export function removeCookie() {
    document.cookie = cookieName + '=; path=/; max-age=-1';
}

export function updateCookieCollapseState(state) {
    let comparisonArr = getComparisonArray();
    comparisonArr[2] = state === 'on' ? 1 : 0;
    setCookie(comparisonArr);
}