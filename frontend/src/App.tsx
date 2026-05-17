import { Route, Routes, Link, useNavigate, useSearchParams } from 'react-router-dom'
import { useForm } from 'react-hook-form'
import { z } from 'zod'
import { zodResolver } from '@hookform/resolvers/zod'
import { useMutation, useQuery } from '@tanstack/react-query'

import { authApi } from './lib/api'
import { useAuth } from './features/auth/AuthProvider'
import { ProtectedRoute } from './components/routing/ProtectedRoute'
import { GuestRoute } from './components/routing/GuestRoute'

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
            Logout
          </button>
        </>
      ) : (
        <>
          <Link to="/login">Login</Link>{' '}
          <Link to="/register">Register</Link>
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
      <h1>FantaMeister</h1>

      {q.isLoading && <p>Loading...</p>}

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
      <h2>Login</h2>

      <input placeholder="email" {...register('email')} />
      <p>{errors.email?.message}</p>

      <input type="password" placeholder="password" {...register('password')} />
      <p>{errors.password?.message}</p>

      <button>Login</button>

      <p>{m.error instanceof Error ? m.error.message : ''}</p>

      <Link to="/forgot-password">Forgot password?</Link>
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
      message: 'Passwords must match',
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
      <h2>Register</h2>

      <input placeholder="name" {...f.register('name')} />
      <input placeholder="email" {...f.register('email')} />

      <input type="password" placeholder="password" {...f.register('password')} />

      <input
        type="password"
        placeholder="confirm password"
        {...f.register('password_confirmation')}
      />

      <button>Register</button>

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
      <h2>Forgot password</h2>

      <input placeholder="email" {...f.register('email')} />

      <button>Send reset link</button>

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
      message: 'Passwords must match',
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
      <h2>Reset password</h2>

      <input type="password" placeholder="password" {...f.register('password')} />

      <input
        type="password"
        placeholder="confirm password"
        {...f.register('password_confirmation')}
      />

      <button>Reset password</button>

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