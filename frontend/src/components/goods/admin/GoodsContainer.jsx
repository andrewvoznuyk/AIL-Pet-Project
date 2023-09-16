import React, { useEffect, useState } from "react";
import axios from "axios";
import { responseStatus } from "../../../utils/consts";
import { Helmet } from "react-helmet-async";
import { Breadcrumbs, Button, Link, Pagination, Typography } from "@mui/material";
import { NavLink, useNavigate, useSearchParams } from "react-router-dom";
import userAuthenticationConfig from "../../../utils/userAuthenticationConfig";
import { checkFilterItem, fetchFilterData } from "../../../utils/fetchFilterData";

const GoodsContainer = () => {

  const navigate = useNavigate();

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