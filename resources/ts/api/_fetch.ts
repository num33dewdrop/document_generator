export const fetchApi = async (url: string, method: string, token: string, params: object = {}) => {
    return await fetch(url, {
        "method": method,
        "headers": {
            "Content-Type": "application/json",
            "X-Method-Override": method,
            "X-CSRF-Token": token,
            "cache": "no-cache"
        },
        "body": JSON.stringify(params)
    });
};