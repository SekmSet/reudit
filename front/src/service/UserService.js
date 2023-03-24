import axios from "./Axios";
import qs from 'qs';


const getUsers = async () => {
    const results = await axios({
        method: 'get',
        url: `/user`,
        responseType: 'json'
    });

    return results.data.result
}

const getUser = async (id) => {
    const result = await axios({
        method: 'get',
        url: `/user/${id}`,
        responseType: 'json'
    });

    return result.data.result
}


const updateUser = () => {
}

const deleteUser = async (id) => {
    const results = await axios({
        method: 'delete',
        url: `/user/${id}`,
        responseType: 'json'
    });
    return results
}

export {
    getUser,
    getUsers,
    updateUser,
    deleteUser,
}