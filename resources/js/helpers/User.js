import Token from './Token';
import AppStorage from './AppStorage';
class User {
    async login(form) {
        try {
            const { data } = await axios.post('/api/auth/login', form);
            Token.payload(data.access_token);

            this.checkLoginData(data);

            return { isError: false, errorStatus: null };
        } catch (error) {
            console.error(error);

            if (error.response && error.response.status) {
                return { isError: true, errorStatus: error.response.status };
            }

            return { isError: true, errorStatus: null };
        }
    }

    checkLoginData(data) {
        const { access_token, username, role } = data;

        if (Token.isValid(access_token)) {
            AppStorage.store(username, access_token, role);
            window.location = '/forum';
        }
    }

    isToken() {
        const storedToken = AppStorage.getToken();

        if (storedToken) {
            return Token.isValid(storedToken) ? true : this.logout();
        }

        return false;
    }

    isLogged() {
        return this.isToken();
    }

    logout() {
        AppStorage.clearStore();
        window.location = '/forum';
    }

    name() {
        if (this.isLogged()) {
            return AppStorage.getUsername();
        }
    }

    id() {
        if (this.isLogged()) {
            const payload = Token.payload(AppStorage.getToken());

            return payload.sub;
        }
    }

    role() {
        if (this.isLogged()) {
            return AppStorage.getRole();
        }
    }

    own(id) {
        return this.id() === id;
    }

    isAdmin() {
        return this.role() === 'admin';
    }
}

export default User = new User();
