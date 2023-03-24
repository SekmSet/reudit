import React, {useEffect, useState} from "react";
import Button from 'react-bootstrap/Button';
import Card from 'react-bootstrap/Card';
import Spinner from 'react-bootstrap/Spinner';
import {deleteLabel, getLabels, updateLabel} from "../../../service/LabelService";
import LabelCreate from "./Create";
import {Table} from "react-bootstrap";

const AdminLabelList = () => {
    const [labels, setLabels] = useState([])
    const [loader, setLoader] = useState(true)

    const fetchData = async () => {
        const results = await getLabels()
        setLabels(results)
        setLoader(false)
    }

    useEffect(() => {
        fetchData().catch(console.error);
    }, [])

    const handleDelete = async (id) => {
        await deleteLabel(id)
        fetchData().catch(console.error);
    }

    const handleUpdate = async (id) => {
        await updateLabel(id)
        fetchData().catch(console.error);
    }

    return (
        <div>
            { loader && (<Spinner animation="border" role="status"></Spinner>) }
            { !loader && labels.length === 0 && (<div>Pas de labels</div>)}

            {labels.length !== 0 && (
                <div>
                    <LabelCreate/>
                </div>
            )}

            <div className="container">
                <Table striped bordered hover>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>X</th>
                        <th>X</th>
                    </tr>
                    </thead>
                    <tbody>
                    {
                        labels && labels.map((label, index) =>
                            <tr key={index}>
                                <td>{index}</td>
                                <td>{label.label}</td>
                                <td><Button onClick={() => handleDelete(label.id)} variant="danger">Delete</Button></td>
                                <td><Button onClick={() => handleUpdate(label.id)} variant="warning">Update</Button></td>
                            </tr>
                        )
                    }
                    </tbody>
                </Table>
            </div>
        </div>
    )
}

export default AdminLabelList