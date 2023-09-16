const FormsFilter = ({ filterData, setFilterData }) => {

  const onChangeFilterData = (event) => {
    event.preventDefault();

    const { name, value } = event.target;

    setFilterData({ ...filterData, [name]: value });
  };

  return <>
    <div>
      <label htmlFor="name">Name: </label>
      <input id="name" type="text" name="name" defaultValue={filterData.name ?? ""} onChange={onChangeFilterData} />
    </div>
  </>;
};

export default FormsFilter;