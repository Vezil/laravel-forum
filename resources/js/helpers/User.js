import Token from './Token';
import AppStorage from './AppStorage';
class User {
    async login(form) {
        try {
            const { data } = await axios.post('/api/auth/login', form);
            Token.payload(data.access_token);

            this.checkLoginData(data);
        } catch (err) {
            console.error(err);
        }
    }

    checkLoginData(data) {
        const { access_token } = data;
        const { username } = data;

        if (Token.isValid(access_token)) {
            AppStorage.store(username, access_token);
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

    own(id) {
        return this.id() === id;
    }

    isAdmin() {
        //@TODO Roles

        return this.id() === 1;
    }
}

export default User = new User();
