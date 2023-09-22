import React, { useEffect, useState } from "react";
import { Helmet } from "react-helmet-async";
import { Button, Table, TableBody, TableCell, TableHead, TableRow } from "@mui/material";
import { NavLink, useNavigate, useSearchParams } from "react-router-dom";
import { checkFilterItem, fetchFilterData } from "../../utils/fetchFilterData";
import axios from "axios";
import userAuthenticationConfig from "../../utils/userAuthenticationConfig";
import { responseStatus } from "../../utils/consts";
import Notification from "../elemets/notification/Notification";
import Grid from "@mui/material/Grid";
import Paper from "@mui/material/Paper";

const CompanyContainer = () => {

  const navigate = useNavigate();
  const [requestData, setRequestData] = useState();
  const [loading, setLoading] = useState(false);
  const [notification, setNotification] = useState({
    visible: false,
    type: "",
    message: ""
  });

  const [companies, setCompanies] = useState(null);
  const [searchParams] = useSearchParams();

  const [paginationInfo, setPaginationInfo] = useState({
    totalItems: null,
    totalPageCount: null,
    itemsPerPage: 10
  });

  const [filterData, setFilterData] = useState({
    "page": checkFilterItem(searchParams, "page", 1, true)
  });

  const loadCompanies = () => {
    let filterUrl = fetchFilterData(filterData);
    navigate(filterUrl);

    axios.get("/api/companies" + filterUrl + "&itemsPerPage=" + paginationInfo.itemsPerPage, userAuthenticationConfig()).then(response => {
      if (response.status === responseStatus.HTTP_OK && response.data["hydra:member"]) {
        setCompanies(response.data["hydra:member"]);
        setPaginationInfo({
          ...paginationInfo,
          totalItems: response.data["hydra:totalItems"],
          totalPageCount: Math.ceil(response.data["hydra:totalItems"] / paginationInfo.itemsPerPage)
        });
      }
    }).catch(error => {
      console.log("error");
    });
  };

  useEffect(() => {
    loadCompanies();
  }, [requestData, filterData]);

  const onChangePage = (event, page) => {
    setFilterData({ ...filterData, page: page });
  };

  return (
    <>
      {notification.visible &&
        <Notification
          notification={notification}
          setNotification={setNotification}
        />
      }
      <Helmet>
        <title>
          Companies
        </title>
      </Helmet>

      <Grid container spacing={1}>
        <Grid item xs={12}>
          <Button
            to="/cabinet/companies/new"
            component={NavLink}
            variant="outlined"
          >
            Create company
          </Button>
        </Grid>

        <Paper>
          <Table aria-label="Company table">
            <TableHead>
              <TableRow>
                <TableCell>Company name</TableCell>
                <TableCell>Date</TableCell>
              </TableRow>
            </TableHead>
            <TableBody>
              {companies && companies.map((company, index) => (
                <TableRow key={index}>
                  <TableCell>{company.name}</TableCell>
                  <TableCell>{company.date}</TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        </Paper>

        <Grid item xs={12}>

        </Grid>
      </Grid>
    </>
  );
};

export default CompanyContainer;