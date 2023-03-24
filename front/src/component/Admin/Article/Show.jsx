import {useParams} from "react-router-dom";
import React, {useEffect, useState} from "react";
import {Badge, Spinner} from "react-bootstrap";
import {getArticle} from "../../../service/ArticleService";

const AdminArticleShow = () => {
    const {id} = useParams();
    const [article, setArticle] = useState({})
    const [loader, setLoader] = useState(true)

    const fetchData = async () => {
        const result = await getArticle(id)
        setArticle(result)
        setLoader(false)
    }

    useEffect(() => {
        fetchData().catch(console.error);
    }, [])


    return (
        <div className="container">
            { loader && (<Spinner animation="border" role="status"></Spinner>) }

            <div>
                <h3> {article?.title} </h3>
                <div>
                    <Badge pill bg="info"> {article?.category?.label} </Badge>
                    <Badge pill bg="dark"> {article?.label?.label} </Badge>
                    <p><span> {article?.author?.name} </span></p>
                    <p><span> {article?.created?.date} </span></p>
                </div>

                <div>
                    {article?.content}
                </div>
            </div>

            <div className="commentBlock">
                {article?.comments && article.comments.map((comment, index) =>
                    <div key={index}>
                        <p>{comment.author?.name}</p>
                        <p>{comment.content}</p>
                    </div>
                )}
            </div>
        </div>
    )
}

export default AdminArticleShow