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
      <Typography variant="h4" component="h1" mt={1} mb={2}>
        Companies
      </Typography>
      <CompaniesCreate />
    </>
  );
};

export default CompaniesContainer;