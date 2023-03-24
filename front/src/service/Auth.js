import axios from "./Axios";
import qs from "qs";

const register = async ({name, email, password}) => {
    const result = await axios({
        method: 'post',
        url: `/user/`,
        responseType: 'json',
        headers: { 'content-type': 'application/x-www-form-urlencoded' },
        data: qs.stringify({
            name,
            email,
            password
        })
    });

    return result
}

const login = async ({email, password}) => {
    const result = await axios({
        method: 'post',
        url: `/login_check`,
        responseType: 'json',
        data: {
            email,
            password
        }
    });

    const { token } = result.data
    return token
}

export {
    register,
    login,
}