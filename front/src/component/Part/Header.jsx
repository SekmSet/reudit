import {Container, Nav, Navbar} from "react-bootstrap";
import {useContext} from "react";
import UserContext from "../../context/UserContext";
import {useNavigate} from "react-router-dom";

const Header = () => {
    const navigate = useNavigate();
    const { isAuth, isAdmin, logout } = useContext(UserContext);

    const handleLogout = async () => {
        await logout()
        navigate('/')
    }

    return (
        <div>
            <Navbar variant="light">
                    <Navbar.Brand href="/">Reudit</Navbar.Brand>
                    <Nav className="me-auto">
                        <Nav.Link href="/article">Article</Nav.Link>

                        { isAuth && isAdmin && <Nav.Link href="/admin">Admin</Nav.Link>}

                        { !isAuth && <Nav.Link href="/login">Login</Nav.Link> }
                        { !isAuth && <Nav.Link href="/register">Register</Nav.Link> }

                        { isAuth && <Nav.Link onClick={handleLogout}>Logout</Nav.Link> }
                    </Nav>
            </Navbar>
        </div>
    )
}

export default Header