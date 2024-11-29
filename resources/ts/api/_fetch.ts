export const fetchApi = async (url: string, method: string, token: string, params: object = {}) => {
    return await fetch(url, {
        "method": method,
        "headers": {
            "Content-Type": "application/json",
            "X-HTTP-Method-Override": method,
            "X-Auth-Token": token,
            "cache": "no-cache"
        },
        "body": JSON.stringify(params)
    });
};