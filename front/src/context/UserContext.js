import React, { useState } from 'react';
import PropTypes from 'prop-types';
import jwt_decode from "jwt-decode";

const UserContext = React.createContext(undefined);

export const UserProvider = ({ children }) => {
    const [token, setToken] = useState(localStorage.getItem('token'));
    const [email, setEmail] = useState(localStorage.getItem('email'));
    const [isAdmin, setIsAdmin] = useState(localStorage.getItem('admin') === 'true');
    const [isAuth, setIsAuth] = useState(token !== null && email !== null);

    const setAuth = ({ token, email }) => {

        const {roles} = jwt_decode(token);
        const hasRoleAdmin = roles.includes("ROLE_ADMIN")

        localStorage.setItem('token', token);
        localStorage.setItem('email', email);
        localStorage.setItem('admin', hasRoleAdmin);
        setToken(token);
        setEmail(email);
        setIsAuth(true);
        setIsAdmin(hasRoleAdmin);
    };

    const logout = () => {
        localStorage.removeItem('token');
        localStorage.removeItem('email');
        localStorage.removeItem('admin');
        setToken('');
        setEmail('');
        setIsAuth(false);
        setIsAdmin(false);
    };

    const data = {
        token,
        email,
        isAuth,
        isAdmin,
        setAuth,
        logout
    };

    return (
        <UserContext.Provider value={data}>
            {children}
        </UserContext.Provider>
    );
};

export const UserConsumer = UserContext.Consumer;
export default UserContext;

UserProvider.propTypes = {
    children: PropTypes.element.isRequired
};
