import React, { useRef } from "react";
import Form from "react-bootstrap/Form";
import Button from "react-bootstrap/Button";
import {postCategory} from "../../../service/CategoryService";

const CategoryCreate = () => {
    const labelRef = useRef();

    const handleSubmit = async (event) => {
        event.preventDefault();

        const label = labelRef.current.value
        await postCategory(label)
    }


    return (
        <div className="container">
            <Form onSubmit={handleSubmit}>
                <Form.Group className="mb-3">
                    <Form.Control ref={labelRef} type="text" placeholder="Label of your category" />
                </Form.Group>

                <Button variant="primary" type="submit">
                    Submit
                </Button>
            </Form>
        </div>
    )
}

export default CategoryCreate