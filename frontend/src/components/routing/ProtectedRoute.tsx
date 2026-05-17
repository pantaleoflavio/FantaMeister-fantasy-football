import { Navigate, Outlet } from 'react-router-dom'
import { useAuth } from '../../features/auth/AuthProvider'

export function ProtectedRoute() {
  const { user, isLoading } = useAuth()
  if (isLoading) return <p>Loading...</p>
  if (!user) return <Navigate to="/login" replace />
  return <Outlet />
}