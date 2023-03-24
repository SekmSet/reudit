import Button from "react-bootstrap/Button";
import {useNavigate} from "react-router-dom";

const Admin = () => {
    const navigate = useNavigate();

    const navigateLabel = () => {
        navigate("/admin/label")
    }
    const navigateUser = () => {
        navigate("/admin/user")
    }
    const navigateCategory = () => {
        navigate("/admin/category")
    }
    const navigateArticle = () => {
        navigate("/admin/article")
    }

    return (
        <div>
            <Button variant="outline-secondary" onClick={navigateLabel}>Label</Button>{' '}
            <Button variant="outline-secondary" onClick={navigateUser}>User</Button>{' '}
            <Button variant="outline-secondary" onClick={navigateCategory}>Category</Button>{' '}
            <Button variant="outline-secondary" onClick={navigateArticle}>Article</Button>{' '}
        </div>
    )
}

export default Admin