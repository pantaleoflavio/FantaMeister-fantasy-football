import { useQuery } from '@tanstack/react-query';
import { authApi } from '../lib/api';

export function HealthPage() {
  const { data, isLoading, isError, error } = useQuery({
    queryKey: ['health'],
    queryFn: authApi.health,
  });

  return (
    <main className="min-h-screen bg-slate-100 p-8 text-slate-900">
      <h1 className="mb-4 text-2xl font-bold">FantaMeister</h1>
      {isLoading && <p>Loading backend status...</p>}
      {isError && <p>Backend error: {(error as Error).message}</p>}
      {data && (
        <div className="rounded bg-white p-4 shadow">
          <p>Status: {data.status}</p>
          <p>Competition code: {data.competition}</p>
        </div>
      )}
    </main>
  );
}
