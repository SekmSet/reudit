import Form from "react-bootstrap/Form";
import Button from "react-bootstrap/Button";
import {useNavigate} from "react-router-dom";
import {useRef} from "react";
import {register} from "../../service/Auth";

const Register = () => {
    const navigate = useNavigate();
    const nameRef = useRef();
    const emailRef = useRef();
    const passwordRef = useRef();
    const handleSubmit = async (event) => {
        event.preventDefault();

        const name = nameRef.current.value
        const email = emailRef.current.value
        const password = passwordRef.current.value

        await register({name, email, password})
        navigate("/login");
    }


    return (
        <div className="container">
            <Form onSubmit={handleSubmit}>
                <Form.Group className="mb-3" controlId="formBasicName">
                    <Form.Label>Name </Form.Label>
                    <Form.Control ref={nameRef} type="text" placeholder="Enter your name" />
                </Form.Group>
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

export default Register