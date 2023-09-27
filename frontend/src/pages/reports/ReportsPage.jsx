import { useContext } from "react";
import Can from "../../components/elemets/can/Can";
import { AppContext } from "../../App";
import { reports } from "../../rbac-consts";
import CabinetDefaultContainer from "../../components/elemets/cabinet/CabinetDefaultContainer";
import ToolbarRoleSwitch from "../../components/elemets/cabinet/toolbars/ToolbarRoleSwitch";
import NotFoundPage from "../notFound/NotFoundPage";
import OwnerReportsContainer from "../../components/reports/owner/OwnerReportsContainer";
import ManagerReportsContainer from "../../components/reports/manager/ManagerReportsContainer";
import AdminReportsContainer from "../../components/reports/admin/AdminReportsContainer";

const ReportsPage = () => {

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
        perform={reports.OWNER}
        yes={() => <OwnerReportsContainer />}
      />
      <Can
        role={user.roles}
        perform={reports.MANAGER}
        yes={() => <ManagerReportsContainer />}
      />
      <Can
        role={user.roles}
        perform={reports.ADMIN}
        yes={() => <AdminReportsContainer />}
      />
    </>
  );
};

export default ReportsPage;