import React from "react";
import { Helmet } from "react-helmet-async";
import { Breadcrumbs, Button, Link, Typography } from "@mui/material";
import { NavLink, useNavigate } from "react-router-dom";

const GoodsContainer = () => {
  return (
    <>
      <Helmet>
        <title>
          Goods
        </title>
      </Helmet>
      <Breadcrumbs aria-label="breadcrumb">
        <Link component={NavLink} underline="hover" color="inherit" to="/">
          Home
        </Link>
        <Typography color="text.primary">Goods</Typography>
      </Breadcrumbs>
      <Typography variant="h4" component="h1" mt={1} mb={2}>
        Goods
      </Typography>
      <Button
        to="/panel/goods/cooperation"
        component={NavLink}
      >
        Cooperation
      </Button>
    </>
  );

};

export default GoodsContainer;