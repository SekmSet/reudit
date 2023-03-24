import axios from "./Axios";
import qs from "qs";

const getLabels = async () => {
    const results = await axios({
        method: 'get',
        url: `/label`,
        responseType: 'json'
    });

    return results.data.result
}

const getLabel  = async (id) => {
    const results = await axios({
        method: 'get',
        url: `/label/${id}`,
        responseType: 'json'
    });

    return results.data.result
}

const postLabel = async (label) => {
    const response = await axios({
        method: 'post',
        url: `/label/`,
        responseType: 'json',
        headers: { 'content-type': 'application/x-www-form-urlencoded' },
        data: qs.stringify({
            label,
        })
    });

    return response.data
}

const updateLabel  = (id, label) => {}

const deleteLabel = async (id) => {
    const results = await axios({
        method: 'delete',
        url: `/label/${id}`,
        responseType: 'json'
    });
    return results
}

export {
    getLabel,
    getLabels,
    postLabel,
    updateLabel,
    deleteLabel,
}