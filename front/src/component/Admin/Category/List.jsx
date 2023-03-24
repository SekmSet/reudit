import React, {useEffect, useState} from "react";
import Button from 'react-bootstrap/Button';
import Card from 'react-bootstrap/Card';
import Spinner from 'react-bootstrap/Spinner';
import {deleteCategory, getCategories, updateCategory} from "../../../service/CategoryService";
import CategoryCreate from "./Create";
import {Table} from "react-bootstrap";

const AdminCategoryList = () => {
    const [categories, setCategories] = useState([])
    const [loader, setLoader] = useState(true)

    const fetchData = async () => {
        const results = await getCategories()
        setCategories(results)
        setLoader(false)
    }

    useEffect(() => {
        fetchData().catch(console.error);
    }, [])

    const handleDelete = async (id) => {
        await deleteCategory(id)
        fetchData().catch(console.error);
    }

    const handleUpdate = async (id) => {
        await updateCategory(id)
        fetchData().catch(console.error);
    }

    return (
        <div>
            { loader && (<Spinner animation="border" role="status"></Spinner>) }
            { !loader && categories.length === 0 && (<div>Pas de catégorie</div>)}
            { categories.length !== 0 && (<div><CategoryCreate/></div>)}

            <div className="container cardView">
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
                        categories && categories.map((category, index) =>
                            <tr key={index}>
                                <td>{index}</td>
                                <td>{category.label}</td>
                                <td><Button onClick={() => handleDelete(category.id)} variant="danger">Delete</Button></td>
                                <td><Button onClick={() => handleUpdate(category.id)} variant="warning">Update</Button></td>
                            </tr>
                        )
                    }
                    </tbody>
                </Table>
            </div>
        </div>
    )
}

export default AdminCategoryList