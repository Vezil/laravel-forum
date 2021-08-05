require('dotenv').config();

const env = (key, defaultValue = null) => process.env[key] || defaultValue;

const config = {
    app: {
        frontendUrl: env('MIX_FRONTEND_URL', 'http://localhost:8000')
    }
};

module.exports = config;
