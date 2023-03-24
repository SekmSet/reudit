import React, {useEffect, useState} from "react";
import {useNavigate, useParams} from "react-router-dom";
import {getCategory, deleteCategory} from "../../../service/CategoryService";
import {Spinner} from "react-bootstrap";

const AdminCategoryShow = () => {
    const [category, setCategory] = useState({})
    const [error, setError] = useState(null)
    const [loader, setLoader] = useState(true)
    const {id} = useParams();

    const navigate = useNavigate();


    useEffect(() => {
        const fetchData = async () => {
            const result = await getCategory(id).catch(e => setError(e.message))
            setCategory(result)
            setLoader(false)
        }

        fetchData().catch(console.error);
    }, [id])

    const handleDelete = async () => {
        await deleteCategory(id)
        navigate("/admin/category")
    };

    return (
        <div className="container">
            {loader && (<Spinner animation="border" role="status"></Spinner>)}
            {error && <div>{error}</div>}
            {!error && (
                <div>
                    {category?.label}
                    <button onClick={handleDelete}>Delete</button>
                </div>
            )}
        </div>
    )
}

export default AdminCategoryShow