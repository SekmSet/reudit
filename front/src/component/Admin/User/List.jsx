import React, {useEffect, useState} from "react";
import {useNavigate} from "react-router-dom";
import {deleteUser, getUsers, updateUser} from "../../../service/UserService";
import {Table} from "react-bootstrap";
import Button from "react-bootstrap/Button";
import Spinner from "react-bootstrap/Spinner";

const AdminUser = () => {
    const [users, setUsers] = useState([])
    const [loader, setLoader] = useState(true)
    const navigate = useNavigate();

    const fetchData = async () => {
        const results = await getUsers()
        setUsers(results)
        setLoader(false)
    }

    useEffect(() => {
        fetchData().catch(console.error);
    }, [])

    const handleDelete = async (id) => {
        await deleteUser(id)
        fetchData().catch(console.error);
    }

    const handleChangeRole = async (id) => {
        await updateUser(id)
        fetchData().catch(console.error);

    }

    console.log(users)
    return (
        <div className="container">
            { loader && (<Spinner animation="border" role="status"></Spinner>) }

            { !loader && users.length !== 0 && (
                <Table striped bordered hover>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>X</th>
                        {/*<th>X</th>*/}
                    </tr>
                    </thead>
                    <tbody>
                    {
                        users && users.map((user, index) =>
                            <tr key={index}>
                                <td>{index}</td>
                                <td>{user.name}</td>
                                <td>{user.email}</td>
                                <td>{user.roles?.join(', ')}</td>
                                <td><Button onClick={() => handleDelete(user.id)} variant="danger">Delete</Button></td>
                                {/*<td><Button onClick={() => handleChangeRole(user.id)} variant="danger">Delete</Button></td>*/}
                            </tr>
                        )
                    }
                    </tbody>
                </Table>
            )}
        </div>
    )
}

export default AdminUser