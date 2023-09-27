import React, { useEffect, useState } from "react";
import { Button, TextField } from "@mui/material";

const FlightsFilter = ({ filterData, setFilterData, fetchProducts }) => {

  const onChangeFilterData = (event) => {
    event.preventDefault();
    let { name, value } = event.target;
    setFilterData({ ...filterData, [name]: value });
  };

  return (
    <>
      <div>
        <TextField label="fromLocation" id="fromLocation" type="text" name="fromLocation" defaultValue={filterData.fromLocation ?? ""} onChange={onChangeFilterData} style={{ margin: 10 }} />
        <TextField label="toLocation" id="toLocation" type="text" name="toLocation" defaultValue={filterData.toLocation ?? ""} onChange={onChangeFilterData} style={{ margin: 10 }} />
        <Button style={{ margin: 10 }} onClick={fetchProducts}>Пошук</Button>
      </div>
    </>
  );

};

export default FlightsFilter;