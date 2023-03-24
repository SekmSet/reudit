import React, {useEffect, useRef} from "react";
import Form from "react-bootstrap/Form";
import Button from "react-bootstrap/Button";
import {getLabels, postLabel} from "../../../service/LabelService";

const LabelCreate = () => {
    const labelRef = useRef();

    useEffect(() => {
        const fetchData = async () => {
            const labelList = await getLabels()
        }

        fetchData().catch(console.error);
    }, [])
    const handleSubmit = async (event) => {
        event.preventDefault();

        const label = labelRef.current.value

        await postLabel(label)
    }


    return (
        <div className="container">
            <Form onSubmit={handleSubmit}>
                <Form.Group className="mb-3">
                    <Form.Control ref={labelRef} type="text" placeholder="Label" />
                </Form.Group>

                <Button variant="primary" type="submit">
                    Submit
                </Button>
            </Form>
        </div>
    )
}

export default LabelCreate