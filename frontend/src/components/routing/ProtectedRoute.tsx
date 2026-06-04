import { Navigate, Outlet } from 'react-router-dom';
import { useAuth } from '../../features/auth/AuthProvider';
import { t } from '../../i18n';

export function ProtectedRoute() {
  const { user, isLoading } = useAuth();
  if (isLoading) return <p>{t('common.loading')}</p>;
  if (!user) return <Navigate to="/login" replace />;
  return <Outlet />;
}
