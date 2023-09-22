import { useContext } from "react";
import Can from "../../components/elemets/can/Can";
import { default as OwnerCompaniesContainer } from "../../components/companiesNew/CompaniesContainer";
import { AppContext } from "../../App";
import { flights } from "../../rbac-consts";
import NotFoundPage from "../notFound/NotFoundPage";
import CabinetDefaultContainer from "../../components/elemets/cabinet/CabinetDefaultContainer";
import ToolbarRoleSwitch from "../../components/elemets/cabinet/toolbars/ToolbarRoleSwitch";

const CompaniesNewPage = () => {

  return (
    <>
      <CabinetDefaultContainer
        Sidebar={<ToolbarRoleSwitch />}
        Content={<ContentRoleSwitch />}
      />
    </>
  );
};

const ContentRoleSwitch = () => {
  const { user } = useContext(AppContext);

  if (!user) {
    return <NotFoundPage />;
  }

  return (
    <>
      <Can
        role={user.roles}
        perform={flights.OWNER}
        yes={() => <OwnerCompaniesContainer />}
      />
    </>
  );
};

export default CompaniesNewPage;