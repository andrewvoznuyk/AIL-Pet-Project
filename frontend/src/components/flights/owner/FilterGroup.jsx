import SearchFilterDefault from "../../elemets/searchFilter/SearchFilterDefault";
import SearchFilterSelective from "../../elemets/searchFilter/SearchFilterSelective";
import Grid from "@mui/material/Grid";
import React from "react";

function FilterGroup ({ filterData, setFilterData }) {

  return <>
    <Grid item xs={3}>
      <SearchFilterDefault
        inputLabel="Airport"
        filterData={filterData}
        setFilterData={setFilterData}
        fieldName="airport.name"
      />
    </Grid>
    <Grid item xs={3}>
      <SearchFilterDefault
        inputLabel="Company"
        filterData={filterData}
        setFilterData={setFilterData}
        fieldName="company.name"
      />
    </Grid>
  </>;
}

export default FilterGroup;