const FormsFilter = ({ filterData, setFilterData }) => {

  const onChangeFilterData = (event) => {
    event.preventDefault();

    const { name, value } = event.target;

    setFilterData({ ...filterData, [name]: value });
  };

  return <>
    <div>
      <label htmlFor="email">Email: </label>
      <input id="email" type="text" name="email" defaultValue={filterData.email ?? ""} onChange={onChangeFilterData} />
    </div>
  </>;
};

export default FormsFilter;