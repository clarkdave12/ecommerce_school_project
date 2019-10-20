const apiDomain = 'http://localhost:8000/';

export const registerURL = apiDomain + 'api/register';
export const loginURL = apiDomain + 'oauth/token';
export const userURL = apiDomain + 'api/user';
export const userRoleURL = apiDomain + 'api/user-role';
export const categoryURL = apiDomain + 'api/categories';
export const getUserURL = apiDomain + 'api/admin/users';
export const productURL = apiDomain + 'api/products';
export const feedbackURL = apiDomain + 'api/feedbacks';
export const cartURL = apiDomain + 'api/carts';

export const getHeader = function () {
    
    const token = getAccessToken()

    const headers = {
        'Accept': 'application/json',
        'Authorization': 'Bearer ' + token
    }

    return headers
}

export const getAccessToken = function () {

    const name = 'access_token=';
    const ca = document.cookie.split(';');

    for(let i = 0; i < ca.length; i++) {
        const c = ca[i];

        while(c.charAt(0) == ' ') {
            c = c.substring(1);
        }

        if(c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }

    }
    return "";
}

export const isAuthenticated = function () {
    if(getAccessToken()) {
        return true
    }
    else {
        return false
    }
}

export const isUserAnAdmin = function () {
    const isAdmin = false
    axios.get(userURL, {headers: getHeader()})
        .then(response => {
            const id = response.data.id
            axios.get(userRoleURL + '/' + id)
                .then(response => {
                    isAdmin = true                    
                })
                .catch(error => {
                    isAdmin = false
                })
        })
        .catch(error => {
            console.log(error)
        })

        return isAdmin
}