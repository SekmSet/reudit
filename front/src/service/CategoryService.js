import axios from "./Axios";
import qs from "qs";

const getCategories = async () => {
    const results = await axios({
        method: 'get',
        url: `/category`,
        responseType: 'json'
    });

    return results.data.result
}

const getCategory = async (id) => {
    const result = await axios({
        method: 'get',
        url: `/category/${id}`,
        responseType: 'json'
    });

    return result.data.result
}

const postCategory = async (label) => {
    const results = await axios({
        method: 'post',
        url: `/category/`,
        responseType: 'json',
        headers: { 'content-type': 'application/x-www-form-urlencoded' },
        data: qs.stringify({
            label,
        })
    });

    return results
}

const updateCategory = async (id, label) => {
    const results = await axios({
        method: 'put',
        url: `/category/${id}`,
        responseType: 'json',
        data: {
            label,
            id
        }
    });
}

const deleteCategory = async (id) => {
    const results = await axios({
        method: 'delete',
        url: `/category/${id}`,
        responseType: 'json'
    });
    return results
}

export {
    getCategory,
    getCategories,
    postCategory,
    updateCategory,
    deleteCategory,
}