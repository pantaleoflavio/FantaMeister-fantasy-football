import { createContext, useContext, useMemo } from 'react'
import { useQuery, useQueryClient } from '@tanstack/react-query'
import { authApi, type AuthUser } from '../../lib/api'

type AuthContextValue = {
  user: AuthUser | null
  isLoading: boolean
  login: (token: string, user: AuthUser) => void
  logout: () => Promise<void>
}

const AuthContext = createContext<AuthContextValue | undefined>(undefined)

export function AuthProvider({ children }: { children: React.ReactNode }) {
  const client = useQueryClient()
  const token = localStorage.getItem('auth_token')
  const { data: user, isLoading } = useQuery({
    queryKey: ['auth', 'me'],
    queryFn: authApi.me,
    enabled: Boolean(token),
    retry: false,
  })

  const value = useMemo<AuthContextValue>(() => ({
    user: user ?? null,
    isLoading,
    login: (newToken, me) => {
      localStorage.setItem('auth_token', newToken)
      client.setQueryData(['auth', 'me'], me)
    },
    logout: async () => {
      await authApi.logout().catch(() => undefined)
      localStorage.removeItem('auth_token')
      client.setQueryData(['auth', 'me'], null)
    },
  }), [client, isLoading, user])

  return <AuthContext.Provider value={value}>{children}</AuthContext.Provider>
}

export function useAuth() {
  const ctx = useContext(AuthContext)
  if (!ctx) throw new Error('useAuth must be used within AuthProvider')
  return ctx
}