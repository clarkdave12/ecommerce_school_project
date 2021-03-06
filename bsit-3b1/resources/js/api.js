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
    profile_history: apiDomain + '/api/profile_history',
    change_profile: apiDomain + '/api/get_change_profile',
    change_email: apiDomain + '/api/change_email',
    change_firstname: apiDomain + '/api/change_firstname',
    change_lastname: apiDomain + '/api/change_lastname',
    change_address: apiDomain + '/api/change_address',
    change_password: apiDomain + '/api/check_password',
    new_products: apiDomain + '/api/new_products',
    change_quantity: apiDomain + '/api/change_quantity',
    get_most_popular: apiDomain + '/api/get_most_popular',
    search_by_category: apiDomain + '/api/search_by_category',
}