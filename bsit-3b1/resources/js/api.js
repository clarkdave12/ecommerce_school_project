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
    const token = window.localStorage.getItem('token');

    const headers = {
        'Accept': 'application/json',
        'Authorization': 'Bearer ' + token
    }

    return headers
}