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
    userFeedback: apiDomain + 'api/user-feedback',
    updateProfile: apiDomain + 'api/update-profile',
    message: apiDomain + 'api/messages',
    specs: apiDomain + 'api/specs',
    messageAdmin: apiDomain + 'api/message_admin',
    messageUser: apiDomain + 'api/message_user',
    productSearch: apiDomain + 'api/product_search',
    purchasedHistory: apiDomain + 'api/orders',
    manageUsers: apiDomain + 'api/manage_users',
    removeUser: apiDomain + 'api/remove_user',
    payments: apiDomain + '/api/payments',
}