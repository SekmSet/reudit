import axios from "./Axios";
import qs from 'qs';


const getArticles = async () => {
    const results = await axios({
        method: 'get',
        url: `/article`,
        responseType: 'json'
    });

    return results.data.result
}

const getArticle = async (id) => {
    const result = await axios({
        method: 'get',
        url: `/article/${id}`,
        responseType: 'json'
    });

    return result.data.result
}

const postArticle = async ({title, content, label, category}) => {
    const response = await axios({
        method: 'post',
        url: `/article/`,
        responseType: 'json',
        headers: { 'content-type': 'application/x-www-form-urlencoded' },
        data: qs.stringify({
            title,
            content,
            label,
            category
        })
    });

    return response.data
}

const updateArticle = () => {
}

const deleteArticle = async (id) => {
    const results = await axios({
        method: 'delete',
        url: `/article/${id}`,
        responseType: 'json'
    });
    return results
}

export {
    getArticle,
    getArticles,
    postArticle,
    updateArticle,
    deleteArticle,
}