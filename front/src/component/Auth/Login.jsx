import {useContext, useRef} from "react";
import {useNavigate} from "react-router-dom";
import Button from 'react-bootstrap/Button';
import Form from 'react-bootstrap/Form';
import {login} from "../../service/Auth";
import UserContext from "../../context/UserContext";
const Login = () => {
    const navigate = useNavigate();
    const { setAuth } = useContext(UserContext);
    const emailRef = useRef();
    const passwordRef = useRef();
    const handleSubmit = async (event) => {
        event.preventDefault();

        const email = emailRef.current.value
        const password = passwordRef.current.value

        const token = await login({email, password})
        setAuth({token, email})
        navigate("/");
    }

    return (
        <div className="container">
            <Form onSubmit={handleSubmit}>
                <Form.Group className="mb-3" controlId="formBasicEmail">
                    <Form.Label>Email address</Form.Label>
                    <Form.Control ref={emailRef} type="email" placeholder="Enter email" />
                    <Form.Text className="text-muted">
                        We'll never share your email with anyone else.
                    </Form.Text>
                </Form.Group>

                <Form.Group className="mb-3" controlId="formBasicPassword">
                    <Form.Label>Password</Form.Label>
                    <Form.Control ref={passwordRef} type="password" placeholder="Password" />
                </Form.Group>
                <Button variant="primary" type="submit">
                    Submit
                </Button>
            </Form>
        </div>
    )
}

export default Login