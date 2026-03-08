import { Ziggy } from '@/ziggy'
import { route as routeZiggy } from 'ziggy-js';

export const route = (name: string, params?: any) =>
    routeZiggy(name, params, undefined, Ziggy)
