import React from "react";
import { Helmet } from "react-helmet-async";
import { Breadcrumbs, Link, Typography } from "@mui/material";
import { NavLink } from "react-router-dom";
import CompaniesCreate from "./CompaniesCreate";

const CompaniesContainer = () => {
  return (
    <>
      <Helmet>
        <title>
          Companies
        </title>
      </Helmet>
      <Breadcrumbs aria-label="breadcrumb">
        <Link component={NavLink} underline="hover" color="inherit" to="/">
          Home
        </Link>
        <Typography color="text.primary">Companies</Typography>
      </Breadcrumbs>
      <Typography variant="h4" component="h1" mt={1} mb={2}>
        Companies
      </Typography>
      <CompaniesCreate />
    </>
  );
};

export default CompaniesContainer;