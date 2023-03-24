import Form from "react-bootstrap/Form";
import Button from "react-bootstrap/Button";
import React, {useRef} from "react";
import {postComment} from "../../service/CommentService";

const CommentCreate = ({id}) => {
    const contentRef = useRef();

    const handleSubmit = async (event) => {
        event.preventDefault();
        const content = contentRef.current.value
        await postComment({content, id})
    }

    return (
        <div>
            <Form onSubmit={handleSubmit}>
                <Form.Group className="mb-3">
                    <Form.Control ref={contentRef} as="textarea" rows={3} />
                </Form.Group>

                <Button variant="primary" type="submit">
                    Submit
                </Button>
            </Form>
        </div>
    )
}

export default CommentCreate