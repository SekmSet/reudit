import { Route, Routes } from "react-router-dom"
import './App.css';
import Home from "./component/Home";
import ArticleShow from "./component/Article/Show";
import ArticleList from "./component/Article/List";
import NotFound from "./component/Error";
import Register from "./component/Auth/Register";
import Login from "./component/Auth/Login";
import Admin from "./component/Admin/Index";
import {UserConsumer, UserProvider} from "./context/UserContext";
import Index from "./component/Profil/Index";
import AdminCategoryShow from "./component/Admin/Category/Show";
import AdminCategoryList from "./component/Admin/Category/List";
import AdminLabelShow from "./component/Admin/Label/Show";
import AdminLabelList from "./component/Admin/Label/List";
import ArticleCreate from "./component/Article/Create";
import AdminUser from "./component/Admin/User/List";
import AdminArticle from "./component/Admin/Article/List";
import AdminArticleShow from "./component/Admin/Article/Show";
import Header from "./component/Part/Header";

function App() {
  return (
      <UserProvider>
        <UserConsumer>
          {({ isAuth, isAdmin }) => (
            <div className="App">
                <Header/>
                <Routes>
                    {isAuth && isAdmin && <Route path="/admin" element={<Admin />} />}
                    {isAuth && isAdmin && <Route path="/admin/label/:id" element={<AdminLabelShow />} /> }
                    {isAuth && isAdmin && <Route path="/admin/label" element={<AdminLabelList />} />}
                    {isAuth && isAdmin && <Route path="/admin/category/:id" element={<AdminCategoryShow />} />}
                    {isAuth && isAdmin && <Route path="/admin/category" element={<AdminCategoryList />} />}
                    {isAuth && isAdmin && <Route path="/admin/user" element={<AdminUser />} />}
                    {isAuth && isAdmin && <Route path="/admin/article/:id" element={<AdminArticleShow />} />}
                    {isAuth && isAdmin && <Route path="/admin/article" element={<AdminArticle />} />}

                    {isAuth && <Route path="/article/create" element={<ArticleCreate />} />}
                    <Route path="/article/:id" element={<ArticleShow />} />
                    <Route path="/article" element={<ArticleList />} />

                    {!isAuth && (<Route path="/login" element={<Login />} /> )}
                    {!isAuth && (<Route path="/register" element={<Register />} />)}
                    {isAuth && (<Route path="/profil" element={<Index />} />)}
                    <Route path="/" element={<Home />} />
                    <Route path="*" element={<NotFound />} />
              </Routes>
            </div>
          )}
        </UserConsumer>
      </UserProvider>
  );
}

export default App;
