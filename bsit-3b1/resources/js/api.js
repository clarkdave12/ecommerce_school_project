const apiDomain = 'http://localhost:8000/';

export const api = {
    register: apiDomain + 'api/register',
    login: apiDomain + 'oauth/token',
    user: apiDomain + 'api/user',
    userRole: apiDomain + 'api/user-role',
    categories: apiDomain + 'api/categories',
    getUser: apiDomain + 'api/admin/user',
    products: apiDomain + 'api/products',
    feedbacks: apiDomain + 'api/feedbacks',
    carts: apiDomain + 'api/carts',
    userProfile: apiDomain + 'api/profile',
    userFeedback: apiDomain + 'api/user-feedback'
}