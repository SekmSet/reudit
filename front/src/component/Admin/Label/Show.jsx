import React, {useEffect, useState} from "react";
import {useNavigate, useParams} from "react-router-dom";
import {getLabel, deleteLabel} from "../../../service/LabelService";
import {Spinner} from "react-bootstrap";

const AdminLabelShow = () => {
    const [label, setLabel] = useState({})
    const [error, setError] = useState(null)
    const [loader, setLoader] = useState(true)
    const {id} = useParams();

    const navigate = useNavigate();

    useEffect(() => {
        const fetchData = async () => {
            const result = await getLabel(id).catch(e => setError(e.message))
            setLabel(result)
            setLoader(false)
        }

        fetchData().catch(console.error);
    }, [id])

    const handleDelete = async () => {
        await deleteLabel(id)
        navigate("/admin/label")
    };

    return (
        <div className="container">
            {loader && (<Spinner animation="border" role="status"></Spinner>)}
            {error && <div>{error}</div>}
            {!error && (
                <div>
                    {label?.label}
                    <button onClick={handleDelete}>Delete</button>
                </div>
            )}
        </div>
    )
}

export default AdminLabelShow