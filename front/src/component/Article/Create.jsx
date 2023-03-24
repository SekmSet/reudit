import React, {useEffect, useRef, useState} from "react";
import {useNavigate} from "react-router-dom";
import {postArticle} from "../../service/ArticleService";
import Form from "react-bootstrap/Form";
import Button from "react-bootstrap/Button";
import {getLabels} from "../../service/LabelService";
import {getCategories} from "../../service/CategoryService";

const ArticleCreate = () => {
    const navigate = useNavigate();

    const titleRef = useRef();
    const contentRef = useRef();
    const labelRef = useRef();
    const categoryRef = useRef();

    const [labels, setLabels] = useState([])
    const [categories, setCategories] = useState([])

    const fetchData = async () => {
        const labelList = await getLabels()
        const categoryList = await getCategories()
        setLabels(labelList)
        setCategories(categoryList)
    }

    useEffect(() => {
        fetchData().catch(console.error);
    }, [])
    const handleSubmit = async (event) => {
        event.preventDefault();

        const title = titleRef.current.value
        const content = contentRef.current.value
        const label = labelRef.current.value
        const category = categoryRef.current.value

        await postArticle({title, content, label, category})
        navigate("/article")
    }

    return (
        <div className="container">
            <Form onSubmit={handleSubmit}>
                <Form.Group className="mb-3">
                    <Form.Label>Title</Form.Label>
                    <Form.Control ref={titleRef} type="text" placeholder="Title" />
                </Form.Group>

                <Form.Group className="mb-3">
                    <Form.Label>Content</Form.Label>
                    <Form.Control ref={contentRef} as="textarea" rows={3} />
                </Form.Group>

                <Form.Group className="mb-3">
                    <Form.Label htmlFor="category">Category</Form.Label>
                    <Form.Select id="category" ref={categoryRef}>
                        {
                            categories && categories.map(category => (
                                <option key={category.id} value={category.id}>{category.label}</option>
                            ))
                        }
                    </Form.Select>
                </Form.Group>

                <Form.Group className="mb-3">
                    <Form.Label htmlFor="label">Label</Form.Label>
                    <Form.Select id="label" ref={labelRef}>
                        {
                            labels && labels.map(label => (
                                <option key={label.id} value={label.id}>{label.label}</option>
                            ))
                        }
                    </Form.Select>
                </Form.Group>

                <Button variant="primary" type="submit">
                    Submit
                </Button>
            </Form>
        </div>
    )
}

export default ArticleCreate