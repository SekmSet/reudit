import React, {useEffect, useState} from "react";
import {deleteArticle, getArticles} from "../../../service/ArticleService";
import Spinner from "react-bootstrap/Spinner";
import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import {useNavigate} from "react-router-dom";

const AdminArticle = () => {
    const [articles, setArticles] = useState(null)
    const [loader, setLoader] = useState(true)
    const navigate = useNavigate();

    const fetchData = async () => {
        const results = await getArticles()
        setArticles(results)
        setLoader(false)
    }

    useEffect(() => {
        fetchData().catch(console.error);
    }, [])

    const handleDelete = async (id) => {
        await deleteArticle(id)
        fetchData().catch(console.error);
    }

    const handleNavigate = async (id) => {
        navigate(`/admin/article/${id}`)
    }

    return (
        <div className="container">
            { loader && (<Spinner animation="border" role="status"></Spinner>) }

            <div className="cardView">
                { articles && articles.map((article, index) =>
                    <Card className="card" key={index} style={{width: '18rem'}}>
                        <Card.Img variant="top" src="https://picsum.photos/200"/>
                        <Card.Body>
                            <Card.Title>{article.title}</Card.Title>
                            <Card.Text>
                                {article.content}
                            </Card.Text>
                            <Button onClick={() => handleNavigate(article.id)} variant="primary">See</Button>
                            <Button onClick={() => handleDelete(article.id)} variant="danger">Delete</Button>
                        </Card.Body>
                    </Card>)}
            </div>
        </div>
    )
}

export default AdminArticle