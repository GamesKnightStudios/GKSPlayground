from itertools import chain
from PIL import Image

logo_raw = Image.open('gks.bmp').tobytes()

logo_nibbs = b''.join(
    bytes([b >> 4, b & 15]) for b in logo_raw
    )

mapping = chain.from_iterable(
    range(x+y, 48+y, 4) for y in (0, 48) for x in range(4)
    )

# The mapping has to be converted to a list since a chain doesn't have an index
mapping = list(mapping)

# The sorting is reversed by looking at the index of each nibble in the mapping
sorted_nibbs = [logo_nibbs[mapping.index(x)] for x in range(96)]

logo_bytes = bytes(
    (sorted_nibbs[n] << 4) | sorted_nibbs[n+1] for n in range(0, 96, 2)
    )

# The logo bytes are padded with zeroes to fill out the header
bytes_out = b'\x00'*260 + logo_bytes + b'\x00'*28

with open('mylogo.gb', 'wb') as f:
    f.write(bytes_out)
