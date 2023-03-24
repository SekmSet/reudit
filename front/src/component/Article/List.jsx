import React, {useEffect, useState} from "react";
import Button from 'react-bootstrap/Button';
import Card from 'react-bootstrap/Card';
import Spinner from 'react-bootstrap/Spinner';

import {getArticles} from "../../service/ArticleService";
import {useNavigate} from "react-router-dom";

const ArticleList = () => {
    const navigate = useNavigate();
    const [articles, setArticles] = useState(null)
    const [loader, setLoader] = useState(true)

    useEffect(() => {
        const fetchData = async () => {
            const results = await getArticles()
            setArticles(results)
            setLoader(false)
        }

        fetchData().catch(console.error);
    }, [])

    const navigateArticle = (id) => {
        navigate(`/article/${id}`)
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
                            <Button variant="primary" onClick={() => navigateArticle(article.id)}>See</Button>
                        </Card.Body>
                    </Card>)}
            </div>
        </div>
    )
}

export default ArticleList