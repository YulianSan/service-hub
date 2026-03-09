export interface PaginationLink {
    url: string | null
    label: string
    active: boolean
    page: number
}

export interface Pagination<T> {
    data: T[]
    current_page: number
    last_page: number
    per_page: number
    total: number
    from: number | null
    to: number | null
    links: PaginationLink[]
}
