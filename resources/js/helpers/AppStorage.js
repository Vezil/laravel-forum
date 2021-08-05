class AppStorage {
    storeToken(token) {
        localStorage.setItem('token', token);
    }

    storeUsername(username) {
        localStorage.setItem('username', username);
    }

    getToken() {
        return localStorage.getItem('token');
    }

    getUsername() {
        return localStorage.getItem('username');
    }

    store(username, token) {
        this.storeToken(token);
        this.storeUsername(username);
    }

    clearStore() {
        localStorage.removeItem('token');
        localStorage.removeItem('username');
    }
}

export default AppStorage = new AppStorage();
