import React, {useContext, useEffect, useState} from "react";
import {useParams} from "react-router-dom";
import {deleteArticle, getArticle} from "../../service/ArticleService";
import {Badge, Spinner} from "react-bootstrap";
import CommentCreate from "../Comment/Create";
import Button from "react-bootstrap/Button";
import UserContext from "../../context/UserContext";
import {deleteComment} from "../../service/CommentService";

const ArticleShow = () => {
    const { email } = useContext(UserContext);
    const [article, setArticle] = useState({})
    const [loader, setLoader] = useState(true)
    const {id} = useParams();

    const fetchData = async () => {
        const result = await getArticle(id)
        setArticle(result)
        setLoader(false)
    }

    useEffect(() => {
        fetchData().catch(console.error);
    }, [])

    const handleDelete = async (id) => {
        await deleteArticle(id)
        fetchData().catch(console.error);
    }

    const handleDeleteComm = async (id) => {
        await deleteComment(id)
        fetchData().catch(console.error);
    }

    const handleUpdateComm = async (id) => {
        await deleteComment(id)
        fetchData().catch(console.error);
    }

    return (
        <div className="container">
            { loader && (<Spinner animation="border" role="status"></Spinner>) }

            <div>
                <h3> {article?.title} </h3>
                <div>
                    <Badge pill bg="info"> {article?.category?.label} </Badge>
                    <Badge pill bg="dark"> {article?.label?.label} </Badge>
                    <p><em> {article?.author?.name} </em></p>
                    <p><em> {article?.created?.date} </em></p>
                </div>

                <div className="articleContent">
                    {article?.content}
                </div>

                <img alt="image" src="https://picsum.photos/200"/>

                <div>
                    {article.author?.email === email &&
                        <Button onClick={() => handleDelete(article.id)} variant="danger">Delete</Button>
                    }
                </div>
            </div>

            { article?.comments?.length > 0 &&
                <div className="commentBlock">
                    {article.comments.map((comment, index) =>
                        <div className="comments" key={index}>
                            <b>{comment.author?.name}</b> - {comment.content}
                            <>
                                {comment.author?.email === email &&
                                    <Button onClick={() => handleDeleteComm(comment.id)} variant="danger">Delete</Button>
                                }

                                {/*{comment.author?.email === email &&*/}
                                {/*    <Button onClick={() => handleUpdateComm(comment.id)} variant="warning">Update</Button>*/}
                                {/*}*/}
                            </>
                        </div>
                    )}
                </div>
            }

            <hr/>
            <CommentCreate
                id={id}
            />
        </div>
    )
}

export default ArticleShow