import axios from "./Axios";
import qs from "qs";

const getComments = async () => {
    const results = await axios({
        method: 'get',
        url: `/comment`,
        responseType: 'json'
    });

    console.log(results.data.result)
    return results.data.result
}

const getComment  = async (id) => {
    const results = await axios({
        method: 'get',
        url: `/comment/${id}`,
        responseType: 'json'
    });
}

const postComment = async ({content, id}) => {
    const results = await axios({
        method: 'post',
        url: `/comment/`,
        responseType: 'json',
        data: qs.stringify({
            content,
            article: id
        })
    });

    return results
}

const updateComment  = () => {}

const deleteComment = async (id) => {
    const results = await axios({
        method: 'delete',
        url: `/comment/${id}`,
        responseType: 'json'
    });
    return results
}

export {
    getComment,
    getComments,
    postComment,
    updateComment,
    deleteComment,
}