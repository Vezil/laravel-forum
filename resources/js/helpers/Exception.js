import User from './User';

const EXPIRED_TOKEN = 'Token is expired';
const INVALID_TOKEN = 'Token is invalid';

class Exception {
    handle(error) {
        console.error(error);

        if (error.response && error.response.data) {
            this.isTokenExpiredOrInvalid(error.response.data);
        }
    }

    isTokenExpiredOrInvalid({ error }) {
        if (error === EXPIRED_TOKEN || error === INVALID_TOKEN) {
            User.logout();
        }
    }
}

export default Exception = new Exception();
