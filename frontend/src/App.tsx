import { Route, Routes, Link, useNavigate, useSearchParams } from 'react-router-dom'
import { useForm } from 'react-hook-form'
import { z } from 'zod'
import { zodResolver } from '@hookform/resolvers/zod'
import { useMutation, useQuery } from '@tanstack/react-query'

import { authApi } from './lib/api'
import { useAuth } from './features/auth/AuthProvider'
import { ProtectedRoute } from './components/routing/ProtectedRoute'
import { GuestRoute } from './components/routing/GuestRoute'
import { t } from './i18n'

function Nav() {
  const { user, logout } = useAuth()
  const nav = useNavigate()

  return (
    <nav>
      {user ? (
        <>
          <span>
            {user.email} ({user.roles.join(', ')})
          </span>

          <button
            onClick={async () => {
              await logout()
              nav('/login')
            }}
          >
             {t('auth.logout')}
          </button>
        </>
      ) : (
        <>
         <Link to="/login">{t('auth.login')}</Link>{' '}
          <Link to="/register">{t('auth.register')}</Link>
        </>
      )}
    </nav>
  )
}

function Home() {
  const q = useQuery({
    queryKey: ['health'],
    queryFn: authApi.health,
  })

  return (
    <div>
       <h1>{t('app.name')}</h1>

      {q.isLoading && <p>{t('common.loading')}</p>}

      {q.data && (
        <p>
          {q.data.status} - {q.data.competition}
        </p>
      )}
    </div>
  )
}

function Login() {
  const { login } = useAuth()
  const nav = useNavigate()

  const schema = z.object({
    email: z.string().email(),
    password: z.string().min(1),
  })

  const {
    register,
    handleSubmit,
    formState: { errors },
  } = useForm<z.infer<typeof schema>>({
    resolver: zodResolver(schema),
  })

  const m = useMutation({
    mutationFn: authApi.login,
    onSuccess: (d) => {
      login(d.token, d.user)
      nav('/')
    },
  })

  return (
    <form onSubmit={handleSubmit((v) => m.mutate(v))}>
      <h2>{t('auth.login')}</h2>

      <input placeholder={t('auth.email')} {...register('email')} />
      <p>{errors.email?.message}</p>

      <input type="password" placeholder={t('auth.password')} {...register('password')} />
      <p>{errors.password?.message}</p>

      <button>{t('auth.login')}</button>

      <p>{m.error instanceof Error ? m.error.message : ''}</p>

      <Link to="/forgot-password">{t('auth.forgotPasswordLink')}</Link>
    </form>
  )
}

function Register() {
  const { login } = useAuth()
  const nav = useNavigate()

  const schema = z
    .object({
      name: z.string().min(1),
      email: z.string().email(),
      password: z.string().min(8),
      password_confirmation: z.string().min(8),
    })
    .refine((v) => v.password === v.password_confirmation, {
      path: ['password_confirmation'],
      message: t('auth.passwordsMustMatch'),
    })

  const f = useForm<z.infer<typeof schema>>({
    resolver: zodResolver(schema),
  })

  const m = useMutation({
    mutationFn: authApi.register,
    onSuccess: (d) => {
      login(d.token, d.user)
      nav('/')
    },
  })

  return (
    <form onSubmit={f.handleSubmit((v) => m.mutate(v))}>
      <h2>{t('auth.register')}</h2>

      <input placeholder={t('auth.name')} {...f.register('name')} />
      <input placeholder={t('auth.email')} {...f.register('email')} />

      <input type="password" placeholder={t('auth.password')} {...f.register('password')} />

      <input
        type="password"
        placeholder={t('auth.confirmPassword')}
        {...f.register('password_confirmation')}
      />

      <button>{t('auth.register')}</button>

      <p>{m.error instanceof Error ? m.error.message : ''}</p>
    </form>
  )
}

function ForgotPassword() {
  const schema = z.object({
    email: z.string().email(),
  })

  const f = useForm<z.infer<typeof schema>>({
    resolver: zodResolver(schema),
  })

  const m = useMutation({
    mutationFn: authApi.forgotPassword,
  })

  return (
    <form onSubmit={f.handleSubmit((v) => m.mutate(v))}>
      <h2>{t('auth.forgotPassword')}</h2>

      <input placeholder={t('auth.email')} {...f.register('email')} />

      <button>{t('auth.sendResetLink')}</button>

      <p>{m.data?.message}</p>
    </form>
  )
}

function ResetPassword() {
  const [params] = useSearchParams()

  const token = params.get('token') ?? ''
  const email = params.get('email') ?? ''

  const schema = z
    .object({
      password: z.string().min(8),
      password_confirmation: z.string().min(8),
    })
    .refine((v) => v.password === v.password_confirmation, {
      path: ['password_confirmation'],
      message: t('auth.passwordsMustMatch'),
    })

  const f = useForm<z.infer<typeof schema>>({
    resolver: zodResolver(schema),
  })

  const m = useMutation({
    mutationFn: (v: z.infer<typeof schema>) =>
      authApi.resetPassword({
        ...v,
        token,
        email,
      }),
  })

  return (
    <form onSubmit={f.handleSubmit((v) => m.mutate(v))}>
      <h2>{t('auth.resetPassword')}</h2>

      <input type="password" placeholder={t('auth.password')} {...f.register('password')} />

      <input
        type="password"
        placeholder={t('auth.confirmPassword')}
        {...f.register('password_confirmation')}
      />

      <button>{t('auth.resetPassword')}</button>

      <p>{m.data?.message}</p>
    </form>
  )
}

export function App() {
  return (
    <>
      <Nav />

      <Routes>
        <Route element={<ProtectedRoute />}>
          <Route path="/" element={<Home />} />
        </Route>

        <Route element={<GuestRoute />}>
          <Route path="/login" element={<Login />} />
          <Route path="/register" element={<Register />} />
        </Route>

        <Route path="/forgot-password" element={<ForgotPassword />} />
        <Route path="/reset-password" element={<ResetPassword />} />
      </Routes>
    </>
  )
}