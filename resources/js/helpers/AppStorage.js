class AppStorage {
    storeToken(token) {
        localStorage.setItem('token', token);
    }

    storeUsername(username) {
        localStorage.setItem('username', username);
    }

    storeRole(role) {
        return localStorage.setItem('role', role);
    }

    getToken() {
        return localStorage.getItem('token');
    }

    getUsername() {
        return localStorage.getItem('username');
    }

    getRole() {
        return localStorage.getItem('role');
    }

    store(username, token, role) {
        this.storeToken(token);
        this.storeUsername(username);
        this.storeRole(role);
    }

    clearStore() {
        localStorage.removeItem('token');
        localStorage.removeItem('username');
        localStorage.removeItem('role');
    }
}

export default AppStorage = new AppStorage();
