import React from "react";
import { TextField } from "@mui/material";
import InputDataLoader from "../input/InputDataLoader";

const SearchFilterSelective = ({
  filterData, setFilterData,
  fieldName = "", inputLabel = "",
  url, searchWord, getOptionLabel
}) => {

  const onChangeFilterData = (v) => {
    const value = v.id;

    filterData[fieldName] = value;
    setFilterData({ ...filterData });
  };

  return <>
    <InputDataLoader
      name=""
      label={inputLabel}
      url={url}
      searchWord={searchWord}
      getOptionLabel={getOptionLabel}
      onChange={(e, v) => onChangeFilterData(v)}
    />
  </>;
};

export default SearchFilterSelective;