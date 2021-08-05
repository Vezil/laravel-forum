import config from '../../../config/index.js';

class Token {
    isValid(token) {
        const payload = this.payload(token);
        if (
            (payload &&
                payload.iss === `${config.app.frontendUrl}/api/auth/login`) ||
            `${config.app.frontendUrl}/api/auth/register`
        ) {
            return true;
        }

        return false;
    }

    payload(token) {
        const payload = token.split('.')[1];

        return this.decode(payload);
    }

    decode(payload) {
        if (this.isBase64(payload)) {
            return JSON.parse(atob(payload));
        }

        return false;
    }

    isBase64(payload) {
        return btoa(atob(payload)).replace(/=/g, '') === payload;
    }
}

export default Token = new Token();
